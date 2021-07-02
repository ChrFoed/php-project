import { Component, OnInit, AfterViewInit, Input } from '@angular/core';
import { DataService } from './../data.service';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.less']
})
export class ProductsComponent implements OnInit {

  @Input() public vendorId: String = 'all';

  products: any = [];

  constructor(private data: DataService) { }

  // Angular 2 Life Cycle event when component has been initialized
  ngOnInit() {
    console.log(this.vendorId);
    this.data.getProductsByVendor(this.vendorId).subscribe((products: any) => {
      this.products = products['data'];
      console.log(this.products)
    });
  }

  updateProduct(product: any) {
    console.log({ 'update': product })
  }

  deleteProduct(identifier: String) {
    console.log({ 'delete': identifier })
  }

}
