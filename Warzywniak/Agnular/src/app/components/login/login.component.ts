import { Component, OnInit } from '@angular/core';
import { LoginService } from 'src/app/services/login.service';
import { UserHistoryService } from 'src/app/services/user-history.service';
import { Cart } from 'src/app/model/cart';
import { CartPosition } from 'src/app/model/cart-position';
import { Records } from 'src/app/model/records';
import { AdminService } from 'src/app/services/admin.service';
import { User } from 'src/app/model/user';
import { Item } from 'src/app/model/item';
import { ShopService } from 'src/app/services/shop.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  private email: string;
  private password: string;
  private loginStatus: string;
  private records: Array<Records> = [];
  private name: string;
  private phone: number;
  private switchAdminConent: string;
  private switchShopContent: string;
  private users: Array<User> = [];
  private choosenUserId: number;
  private products: Array<Item> = [];
  private item: Item;
  private available: boolean;

  constructor(private loginService: LoginService, private userHistoryService: UserHistoryService,
    private adminService: AdminService, private shopService: ShopService) {

    this.loginService.getLoginStatus().subscribe((loginStatus: string) => {
      this.loginStatus = loginStatus;
    })
    this.userHistoryService.getHistoryObs().subscribe((records: Array<Records>) => {
      this.records = records;
    })
    this.adminService.getUsersObs().subscribe((users: Array<User>) => {
      this.users = users;
    })
    this.shopService.getSelected().subscribe((products: Array<Item>) => {
      this.products = products;
    })
    this.email = "admin@warzywniak.pl";
    this.password = "admin";
    this.item = {
      id_item: '',
      name: '',
      available: false,
      image: '',
      describe: '',
      price: 0
    }
  }

  ngOnInit() {
  }
  loginUser() {
    this.loginService.login(this.email, this.password);
  }
  logout() {
    this.switchAdminConent='0';
    this.switchShopContent='0';
    this.records=[];
    this.loginService.logut();
  }
  showUserProducts() {
    this.userHistoryService.readHistory(this.loginService.getIdUser());
    console.log(this.records);
  }
  deleteAccount() {
    this.loginService.deleteAccount();
    this.loginService.logut();
  }
  singup() {
    this.loginService.singup(this.email, this.name, this.phone, this.password);
  }
  adminDeleteAccount(id: number) {
    this.loginService.deleteAccount(id);
  }
  showUsers() {
    this.switchAdminConent = "1";
    this.adminService.getUsers();
  }
  showUserHistory(id: number) {
    this.records=[];
    this.userHistoryService.readHistory(id);
  }
  showProducts() {
    this.switchAdminConent = "2";
    this.shopService.readAll();
  }
  addProduct() {
    this.adminService.addProduct(this.item.name, this.item.available, this.item.describe, this.item.price);
  }
  updateProduct() {
    this.adminService.updateProduct(this.item.id_item, this.item.name, this.item.available, this.item.describe, this.item.price);
  }
  formatter(value) {
    return (value == true) ? 'Tak' : 'Nie';
  }
}
