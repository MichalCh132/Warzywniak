import { Component, OnInit } from '@angular/core';
import { Item } from 'src/app/model/item';
import { MenuService } from 'src/app/services/menu.service';

@Component({
  selector: 'app-main-panel',
  templateUrl: './main-panel.component.html',
  styleUrls: ['./main-panel.component.css']
})
export class MainPanelComponent implements OnInit {

switchText: string;
  constructor(private menuService: MenuService) {
    this.menuService.getSelected().subscribe((text: string)=>{
      this.switchText=text;
    }
    )
  }

  ngOnInit() {
  }
}
