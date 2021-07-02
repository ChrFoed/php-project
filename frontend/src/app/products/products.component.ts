import { Component, OnInit, AfterViewInit, Input } from '@angular/core';
import { DataService } from './../data.service';
import { HelperService } from './../helper.service';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.less']
})
export class ProductsComponent implements OnInit {

  @Input() public vendorId: String = 'all';

  products: any = [];

  evalPrice: any;

  constructor(private data: DataService, private helper: HelperService) {
    this.evalPrice = this.helper.evalPrice;
  }

  // Angular 2 Life Cycle event when component has been initialized
  ngOnInit() {
    console.log(this.vendorId);
    this.data.getLastProductsStateByVendor(this.vendorId).subscribe((products: any) => {
      this.products = products['data'];
    });
  }

  updateProduct(product: any) {
    console.log({ 'update': product })
  }

  deleteProduct(identifier: String) {
    console.log({ 'delete': identifier })
  }

}
