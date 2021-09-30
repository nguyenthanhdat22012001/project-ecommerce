import React from 'react';
import { Link } from 'react-router-dom';
import Rating from '@mui/material/Rating';
import "../../styles/Product2.scss";

class Product2 extends React.Component{
    render() {
        return (
            <div className="product2 flexBoxColunm">
            <Link>
                <div className="product2__image">
                    <img src="../assets/img1.jpg" alt="" />
                </div>
                <div className="product2__content">
                    <h3 className="product2__title" >ao tam kim sa ao tam kim sa ao tam kim sa kim sa ao tam kim ao tam kim sa ao tam kim sa ao tam kim sa kim sa ao tam kim</h3>
                    <div className="product2__price">56.000 ₫</div>
                    <div className="product2__rating">
                        <Rating name="half-rating-read" defaultValue={5} precision={0.5} size="small" readOnly />
                    </div>
                </div>
            </Link>
        </div>
        )
    }
}

export default Product2;