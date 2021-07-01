import { Component, OnInit, Input } from '@angular/core';
import { DataService } from './../data.service';

@Component({
  selector: 'app-product1',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.less']
})
export class ProductComponent implements OnInit {

  @Input() public productId: String = 'all';

  expandFlag: Boolean = false;

  timepoints: any = [];

  displayedColumns = ['updated_at', 'price', 'targetprice', 'diff'];

  constructor(private data: DataService) { }

  ngOnInit(): void {
    console.log(this.productId)
    this.data.getProductById(this.productId).subscribe((timepoints: any) => {
      this.timepoints = timepoints['data'];
      console.log(this.timepoints)
    });
  }

  showTimepoints() {
    if (this.expandFlag) this.expandFlag = false;
    else this.expandFlag = true;
  }

  evalPrice(target: Number, current: Number) {
    if (target < current) return 'over-price';
    if (target > current) return 'under-price';
    return 'even-price';
  }

}

// export class ProductComponent implements OnInit {
//
//   @Input() public productId: String = 'all';
//
//   expandFlag: Boolean = false;
//
//   timepoints: any = [];
//
//   constructor(private data: DataService) { }
//
//   ngOnInit(): void {
//     this.data.getProductsByVendor(productId).subscribe((timepoints: any) => {
//       this.timepoints = timepoints['data'];
//       console.log(this.timepoints)
//     });
//   }
//
//   showTimepoints() {
//     if (this.expandFlag) this.expandFlag = false;
//     else this.expandFlag = true;
//   }
//
// }
