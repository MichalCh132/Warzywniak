import { Component, OnInit, Input } from '@angular/core';
import { Item } from 'src/app/model/item';
import { CartService } from 'src/app/services/cart.service';

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.css']
})
export class ItemComponent implements OnInit {


  @Input() 
  item: Item;
  @Input() 
  idnumber: string;
  @Input() 
  amount: number = 1;
  
  constructor(private cartService: CartService) { 
  }

  addItem(){
    if(this.amount===null)return;
    console.log(this.item);
    this.cartService.add(this.item,this.amount);
  }
  ngOnInit() { 
  }

}
