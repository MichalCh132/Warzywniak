import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MenuService {

  private selected: string;
  private selectedObs = new BehaviorSubject<string>('');
  
  constructor() {
    this.selectedObs.next(this.selected);
   }
  select(selected: string){
    this.selected=selected;
    this.selectedObs.next(this.selected);
  }
  getSelected(){
    return this.selectedObs.asObservable();
  }
}
