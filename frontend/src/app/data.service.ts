import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from './../environments/environment';

@Injectable({
  providedIn: 'root'
})


export class DataService {

  headers = new HttpHeaders({ 'Content-Type': 'application/json' });

  API = `${environment.apiUrl}/api`;

  constructor(private http: HttpClient) { }

  /**
   * Returns all products of all vendors
   * @return json
   */
  getProducts() {
    return this.http.get<any>(`${this.API}/products`);
  }

  /**
   * delete product from database
   * @param  id productId
   * @return  HttpResponse
   */
  deleteProduct(identifier: String) {
    return this.http.delete<any>(`${this.API}/products/${identifier}`);
  }

  /**
   * update Product by productId
   * @param  payload product object
   * @return HttpResponse
   */
  updateProduct(payload: Object) {
    return this.http.post<any>(`${this.API}/products`, payload);
  }

  /**
   * add Product by productId
   * @param  payload product object
   * @return json
   */
  addProduct(payload: Object) {
    return this.http.put<any>(`${this.API}/products`, payload, { 'headers': this.headers, 'responseType': 'json' });
  }

  /**
   * returns products linked to vendorId
   * @param  vendor vendorId
   * @return        json
   */
  getProductsByVendor(vendorId: String) {
    return this.http.get<any>(`${this.API}/products/vendor/${vendorId}`);
  }

  /**
   * Returns all timepoints to an product id
   * @param  id [description]
   * @return    [description]
   */
  getProductById(id: String) {
    return this.http.get<any>(`${this.API}/products/${id}`);
  }

  /**
   * return all vendors
   * @return json
   */
  getVendors() {
    return this.http.get<any>(`${this.API}/vendors`);
  }

  /**
   * get Last State of Product by Vendor
   * @param  vendorId String
   * @return json
   */
  getLastProductsStateByVendor(vendorId: String) {
    return this.http.get<any>(`${this.API}/products/vendor/last/${vendorId}`);
  }

  /**
   * scraps Product by Identifier
   * @param  vendorId  [description]
   * @param  identifer [description]
   * @return           [description]
   */
  scrapProductById(vendorId: String, identifer: String) {
    return this.http.get<any>(`${this.API}/scraper/${vendorId}/${identifer}`);
  }

}
