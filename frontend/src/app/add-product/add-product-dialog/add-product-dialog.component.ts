import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { DataService } from './../../data.service';
import { HelperService } from './../../helper.service';

export interface DialogData {
  vendor: 'amazon' | 'cyberport' | 'etec';
  url: "";
  targetprice: 0;
  description: ""
}

@Component({
  selector: 'app-add-product-dialog',
  templateUrl: './add-product-dialog.component.html',
  styleUrls: ['./add-product-dialog.component.less']
})
export class AddProductDialogComponent implements OnInit {

  isLinear = true;
  firstFormGroup: FormGroup;
  secondFormGroup: FormGroup;
  urlRegex: RegExp = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
  urlParts: RegExp = /(?<!\?.+)(?<=\/)[\w-]+(?=[/\r\n?]|$)/g;



  constructor(private _formBuilder: FormBuilder, protected dataService: DataService, protected helperService: HelperService, public dialogRef: MatDialogRef<AddProductDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData) {
    this.firstFormGroup = this._formBuilder.group({
      vendor: [this.data.vendor, Validators.required],
      url: [this.data.url, [Validators.required, Validators.pattern(this.urlRegex)]]
    });
    this.secondFormGroup = this._formBuilder.group({
      targetprice: [this.data.targetprice, [Validators.required, Validators.min(1)]],
      description: [this.data.description, [Validators.required]]
    });
  }

  ngOnInit() {
    this.firstFormGroup = this._formBuilder.group({
      vendor: [this.data.vendor, Validators.required],
      url: [this.data.url, [Validators.required, Validators.pattern(this.urlRegex)]]
    });
    this.secondFormGroup = this._formBuilder.group({
      targetprice: [this.data.targetprice, [Validators.required, Validators.min(1)]],
      description: [this.data.description, [Validators.required]]
    });
  }

  addProduct() {
    let productData = { ...this.firstFormGroup.value, ...this.secondFormGroup.value };
    const matches = [...productData.url.matchAll(this.urlParts)];
    productData = {
      ...this.helperService.evalUrlContent(productData.vendor, matches), ...productData
    };
    productData.url = this.helperService.cleanUrl(productData.vendor, productData.url);
    this.dataService.addProduct(productData).subscribe((response: Object) => {
      console.log(response)
    });
  }
}
