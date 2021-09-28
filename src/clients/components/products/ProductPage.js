import React from 'react';

// import Routers from './pages/Router';
import "../../styles/Product.scss";


class ProductPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {}
    };

    render() {
        return (
            <div className="product__wrapper">
                <sidebar className="product__sidebar">
                     
                </sidebar>
                <article className="product__content">

                </article>
            </div>
        );
    }
}



export default ProductPage;
