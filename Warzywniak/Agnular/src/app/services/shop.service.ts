import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Item } from '../model/item';

@Injectable({
  providedIn: 'root'
})
export class ShopService {

  private results: Array<Item>;
  private resultsObs = new BehaviorSubject<Array<Item>>([]);
   
  constructor(private http: HttpClient) {
   }

  readAll() {
    this.http.get('http://localhost/Warzywniak/api/api/item/read.php', { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.results = data['records'];
      }, (error) => {
        console.log('Errorr!', error);
      },
      () => {this.resultsObs.next(this.results);}
    );
  }
  getSelected(){
    return this.resultsObs.asObservable();
  }
}
