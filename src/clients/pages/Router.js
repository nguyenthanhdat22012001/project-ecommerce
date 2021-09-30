import React from 'react';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import HomePage from "../components/home/HomePage";
import ProductPage from "../components/products/ProductPage";
import ProductDetailPage from "../components/products/ProductDetailPage";

class Routers extends React.Component {
  render() {
    return (
      <Router>
        <Switch>
          <Route exact path="/" >
            <HomePage />
          </Route>
          <Route path="/product" >
            <ProductPage />
          </Route>
          <Route path="/:id.html" >
            <ProductDetailPage />
          </Route>
        </Switch>
      </Router>
    );
  }
}



export default Routers;
