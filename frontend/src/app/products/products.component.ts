import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.less']
})
export class ProductsComponent implements OnInit {

  @Input() public products: Object[] = [];


  constructor() { }

  ngOnInit(): void {
  }

}
