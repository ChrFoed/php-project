import { Component, OnInit, Input } from '@angular/core';
import { DataService } from './../data.service';
import { HelperService } from './../helper.service';

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

  evalPrice: any;


  constructor(private data: DataService, private helper: HelperService) {
    this.evalPrice = this.helper.evalPrice;
  }

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
