import { Component, OnInit, AfterViewInit } from '@angular/core';
import { CartService } from 'src/app/services/cart.service';
import { Item } from 'src/app/model/item';
import { LoginService } from 'src/app/services/login.service';
import { MenuService } from 'src/app/services/menu.service';
@Component({
  selector: 'app-order-list',
  templateUrl: './order-list.component.html',
  styleUrls: ['./order-list.component.css']
})
export class OrderListComponent implements OnInit {

  private amountList: Array<number>;
  private itemList: Array<Item>;
  private loginStatus: string;

  constructor(private cartService: CartService, private loginService: LoginService, private menuService: MenuService) {
    this.loginService.getLoginStatus().subscribe((loginStatus:string) =>{
      this.loginStatus=loginStatus;
    })
    this.cartService.getAmount().subscribe((amountList: Array<number>) => {
      this.amountList = amountList;
    });
    this.cartService.getList().subscribe((itemList: Array<Item>) => {
      this.itemList = itemList;
    });
  }

  ngOnInit() {
    this.loginService.refresh();
    if (this.loginStatus === 'REJECTED') {
      setTimeout(() => { 
        alert('Musisz sie zalogowac aby złożyć zamówienie!');
        this.exit();
    }, 300);
    }

  }

  exit() {
    this.menuService.select('loginPanel')
  }

  getAmount(id: number) {

    return this.amountList[id];
  }
  totalPrice() {
    let price = 0;
    for (let i = 0; i < this.amountList.length; i++) {
      price += this.amountList[i] * this.itemList[i].price;
    }
    return price;
  }
  delete(i: number) {
    this.cartService.deleteItem(i);
  }
  deleteAll() {
    this.cartService.deleteAll();
  }

  sendOrder(){
    this.cartService.createCart();
  }

}
