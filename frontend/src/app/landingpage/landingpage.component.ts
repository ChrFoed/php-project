import { Component, OnInit } from '@angular/core';
import { DataService } from './../data.service';

@Component({
  selector: 'app-landingpage',
  templateUrl: './landingpage.component.html',
  styleUrls: ['./landingpage.component.less']
})
export class LandingpageComponent implements OnInit {

  vendors: any[] = [{
    label: "Amazon.de",
    id: "amazon"
  },
  {
    label: "Cyperport AT",
    id: "cyperport"
  }, {
    label: "E-Tec",
    id: "etec"
  }]

  constructor(private data: DataService) { }

  // Angular 2 Life Cycle event when component has been initialized
  ngOnInit() {
    // this.data.getVendors().subscribe((vendors: any) => {
    //   this.vendors = vendors.
    // });
  }
}
