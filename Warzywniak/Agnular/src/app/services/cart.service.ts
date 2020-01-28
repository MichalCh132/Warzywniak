import { Injectable } from '@angular/core';
import { Item } from '../model/item';
import { BehaviorSubject } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { LoginService } from './login.service';
import { Cart } from '../model/cart';

@Injectable({
  providedIn: 'root'
})
export class CartService {

  itemList: Array<Item> =[];
  itemListObs = new BehaviorSubject<Array<Item>>([]);
  amountList: Array<number>= [];
  amountListObs = new BehaviorSubject<Array<number>>([]);
  private actualCart: Cart;

  constructor(private http: HttpClient,private loginService:LoginService) {
    this.itemListObs.next(this.itemList);
    this.actualCart = {
      id_cart: undefined,
      id_user : undefined,
      date : undefined
    }
   }
  add(item: Item,amount: number){
    for(let i = 0;i < this.itemList.length;i++){
      if(item.id_item==this.itemList[i].id_item){
        this.amountList[i]+=amount;
        return;
      }
    }
    this.itemList.push(item);
    this.amountList.push(amount);
    this.itemListObs.next(this.itemList);
    this.amountListObs.next(this.amountList);
  }
  deleteItem(i: number){
    this.itemList.splice(i,1);
    this.itemListObs.next(this.itemList);
    this.amountList.splice(i,1);
    this.amountListObs.next(this.amountList);
  }
  deleteAll(){
    this.itemList=[];
    this.itemListObs.next(this.itemList);
    this.amountList=[];
    this.amountListObs.next(this.amountList);
  }
  getList(){
    return this.itemListObs.asObservable();
  }
  getAmount(){
    return this.amountListObs.asObservable();
  }
  createCart(){
    const data = {
      id_user: this.loginService.getIdUser()
    }
    this.http.post('http://localhost/Warzywniak/api/api/cart/create.php',data, { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{ this.readActual()}
    );
  }

    readActual(){
    this.http.get('http://localhost/Warzywniak/api/api/cart/read_actual.php?id_user='+this.loginService.getIdUser(), { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.actualCart.id_user=data['id_user'];
        this.actualCart.id_cart=data['id_cart'];
        this.actualCart.date=data['date'];
        console.log('Got some data from backend: ', data);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{ this.sendCartPositions()}
    );
  }
  
  sendCartPositions(){
    for(let i=0;i<this.itemList.length;i++){
      const data = {
        "id_item" : this.itemList[i].id_item,
        "id_cart" : this.actualCart.id_cart,
        "price"   : this.itemList[i].price,
        "quantity": this.amountList[i]
      }
      this.http.post('http://localhost/Warzywniak/api/api/cart_position/create.php',data, { responseType: 'json' }
      ).subscribe(
        (data: Response) => {
          console.log('Got some data from backend: ', data);
        }, (error) => {
          console.log('Errorr!', error);
        },
        () =>{}
      );
    }
  }

  getCartsHistory(){
    
  }

}
