import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LoginService } from './login.service';
import { Cart } from '../model/cart';
import { CartPosition } from '../model/cart-position';
import { BehaviorSubject } from 'rxjs';
import { Records } from '../model/records';

@Injectable({
  providedIn: 'root'
})
export class UserHistoryService {
  getCartsPositionsObs() {
    throw new Error("Method not implemented.");
  }

  constructor(private http: HttpClient,private loginService:LoginService) { }
  
  private carts: Array<Cart>;
  private cartPositions: Array<CartPosition>;
  private cartsObs = new BehaviorSubject<Array<Cart>>([]);
  private cartPositionsObs = new BehaviorSubject<Array<CartPosition>>([]);
  private records: Array<Records>;
  private recordsObs = new BehaviorSubject<Array<Records>>([]);
  
  readCards(){
    this.http.get('http://localhost/Warzywniak/api/api/cart/read_by_user.php?iduser='+this.loginService.getIdUser(), { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.carts=data['records'];
        console.log(this.carts);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{this.cartsObs.next(this.carts);}
    );
  }

  readPositions(){
    this.http.get('http://localhost/Warzywniak/api/api/cart_position/read_by_cart.php?idcart=28', { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.records=data['records'];
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{this.recordsObs.next(this.records);}
    );
  }

  getCartsObs(){
    return this.cartsObs.asObservable();
  }
  getPositionsObs(){
    return this.cartPositionsObs.asObservable();
  }

  readHistory(id?: number){
    if(id==undefined)this.loginService.getIdUser();
    this.http.get('http://localhost/Warzywniak/api/api/cart/read_history.php?iduser='+id, { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.records=data['records'];
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{this.recordsObs.next(this.records);}
    );
  }
  getHistoryObs(){
    return this.recordsObs.asObservable();
  }
}
