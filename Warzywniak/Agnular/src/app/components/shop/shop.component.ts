import { Component, OnInit } from '@angular/core';
import { Item } from 'src/app/model/item';
import { ShopService } from 'src/app/services/shop.service';

@Component({
  selector: 'app-shop',
  templateUrl: './shop.component.html',
  styleUrls: ['./shop.component.css']
})
export class ShopComponent implements OnInit {

  itemList: Array<Item> = [];

  constructor(private shopService: ShopService) {
    this.shopService.getSelected().subscribe((itemList: Array<Item>)=>{
      this.itemList=itemList;
      console.log(this.itemList);
    });
    shopService.readAll();
    console.log(this.itemList);
    }

  ngOnInit() {
  }

}
