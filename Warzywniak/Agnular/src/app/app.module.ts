import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { BackgroundComponent } from './components/background/background.component';
import { MenuComponent } from './components/menu/menu.component';
import { MainPanelComponent } from './components/main-panel/main-panel.component';
import { ItemComponent } from './components/item/item.component';
import { AlertModule } from 'ngx-bootstrap';
import { ShopComponent } from './components/shop/shop.component';
import { NewsComponent } from './components/news/news.component';
import { CalendarComponent } from './components/calendar/calendar.component';
import { LoginComponent } from './components/login/login.component';
import { CartComponent } from './components/cart/cart.component';
import { HttpClientModule } from '@angular/common/http'; 
import { FormsModule } from '@angular/forms';
import { OrderListComponent } from './components/order-list/order-list.component';
import { SingupComponent } from './components/singup/singup.component';
@NgModule({
  declarations: [
    AppComponent,
    BackgroundComponent,
    MenuComponent,
    MainPanelComponent,
    ItemComponent,
    ShopComponent,
    NewsComponent,
    CalendarComponent,
    LoginComponent,
    CartComponent,
    OrderListComponent,
    SingupComponent
  ],
  imports: [                            //do postowania //do ([ngModel])
    BrowserModule,AlertModule.forRoot(),HttpClientModule,FormsModule 
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
