import { Component, OnInit } from '@angular/core';
import { MenuService } from 'src/app/services/menu.service';
import { LoginService } from 'src/app/services/login.service';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.css']
})
export class MenuComponent implements OnInit {

  private loginStatus: string;

  constructor(private menuService:MenuService,private loginService: LoginService) { 
    loginService.getLoginStatus().subscribe((loginStatus:string)=>{
      this.loginStatus=loginStatus;
    });
    
  }

  change(string:string){
    this.loginService.refresh();
    this.menuService.select(string);
  }
  ngOnInit() {
  }

}
