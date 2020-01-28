import { Component, OnInit } from '@angular/core';
import { Item } from 'src/app/model/item';
import { CartService } from 'src/app/services/cart.service';
import { MenuService } from 'src/app/services/menu.service';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {

itemList: Array<Item>
amountList: Array<number>

  constructor(private cartService: CartService,private menuService: MenuService) { 
    this.cartService.getList().subscribe((itemList: Array<Item>)=>{
      this.itemList=itemList;
      console.log(this.itemList);
    });
    this.cartService.getAmount().subscribe((amountList: Array<number>)=>{
      this.amountList=amountList;
      console.log(this.amountList);
    });
    
    this.body = 'bodymin';
    this.zawartosc = 'none';}

  body: string;
  zawartosc: string; //przerobic na ang
  

  towary: Array<Item>;  //przerobic na ang
  getAmount(id:number){
    return this.amountList[id];
  }
  ngOnInit() {
  }
  bodyChange(){
    if(this.body==='bodymin'){
      this.body = 'bodymax';
      this.zawartosc='full';
    }
    else {
      this.body='bodymin';
    this.zawartosc='none';}
    console.log(this.body);
  }

  buy(){
    this.menuService.select('orderList');
    this.bodyChange();
  }
}
