import React from 'react';

import "../../styles/Product.scss";
import ButtonAddCart from './ButtonAddCart';
import FavoriteBorderIcon from '@mui/icons-material/FavoriteBorder';
import IconButton from '@mui/material/IconButton';
import Rating from '@mui/material/Rating';
import { Link } from 'react-router-dom';


class Product extends React.Component {
    // constructor(props) {
    //     super(props);
    //     this.state = {}
    // };

    render() {
        return (
            <div className="product__item">
                <div className="product__favorit">
                    <IconButton aria-label="delete" color="error" >
                        <FavoriteBorderIcon sx={{ fontSize: 40 }}/>
                    </IconButton>
                </div>
                <div className="product__sale">
                    <span className="saleIcon">-40%</span>
                </div>
                <div className="product__image">
                    <img src="../assets/img1.jpg" alt="" />
                </div>
                <div class="product__content">
                     <Link to="#">
                        <h3 class="product__title">
                            myth time about fiftytheen! myth time about fiftytheen!
                        </h3>
                    </Link>
                    <div className="product__btn">
                        <ButtonAddCart />
                        <ButtonAddCart />
                    </div>
                    <div className="product__buyRating">
                        <span className="product__buy">Đã bán: 1200 sản phẩm</span>
                        <span className="product__rating">
                            <Rating name="half-rating-read" defaultValue={5} precision={0.5} readOnly />
                        </span>
                    </div>
                </div>
            </div>
        );
    }
}



export default Product;
