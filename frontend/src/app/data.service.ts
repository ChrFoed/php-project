import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})


export class DataService {


  API = 'http://localhost:8000/';

  constructor(private http: HttpClient) { }

  getProducts() {
    return this.http.get<any>(`${this.API}/products`);
  }

  getProductById(String id) {
    return this.http.get<any>(`${this.API}/products/${id}`);
  }

}
