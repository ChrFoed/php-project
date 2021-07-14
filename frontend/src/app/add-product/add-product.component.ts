import { Component, OnInit, Input } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { AddProductDialogComponent } from './add-product-dialog/add-product-dialog.component';


@Component({
  selector: 'app-add-product',
  templateUrl: './add-product.component.html',
  styleUrls: ['./add-product.component.less']
})
export class AddProductComponent implements OnInit {

  @Input() public vendorId: String = 'all';

  constructor(public dialog: MatDialog) { }

  ngOnInit(): void {
  }

  openDialog() {
    this.dialog.open(AddProductDialogComponent, {
      data: {
        vendor: 'amazon',
        url: '',
        targetprice: 1,
        description: ''
      }
    });


  }

}
