import React from 'react';
import { Link } from 'react-router-dom';
import IconButton from '@mui/material/IconButton';
import DeleteIcon from '@mui/icons-material/Delete';
import Button from '@mui/material/Button';
import AddIcon from '@mui/icons-material/Add';
import RemoveIcon from '@mui/icons-material/Remove';

import "../../styles/CartPage.scss";
import Stepper from "./Stepper";


class CartPage extends React.Component {


  render() {
    return (
      <div className="row shopping">
        <Stepper stepCart={0} />
        <div class="cart">
          <div class="cart__info table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th></th>
                  <th>Tên sản phẩm</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Thành tiền</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr class="cart__product-item">
                  <td class="cart__product__image">
                    <Link to="/san-pham/dam-body-ca-tinh-voi-nhieu-mau-sac-hien-dai-tre-trung.html">
                      <img class="img-responsive" src="../assets/img1.jpg" alt="" />
                    </Link>
                  </td>
                  <td class="cart__product__desc">
                    <Link to="" class="ng-binding">Đầm body cá tình với nhiều màu sắc hiện đại, trẻ trung Đầm body cá tình với nhiều màu sắc hiện đại, trẻ trung trẻ trung Đầm body cá tình với nhiều màu sắc hiện đại, trẻ trung</Link>
                    <span >Đỏ</span>
                  </td>
                  <td class="cart__product__price">400,000đ</td>
                  <td class="cart__product__quanty">
                    <div className="inputUpDown">
                      <IconButton aria-label="delete" size="small"  >
                        <RemoveIcon color="disabled" />
                      </IconButton>
                      <input className="inputUpDown__input" type="number" defaultValue="1" />
                      <IconButton aria-label="delete" size="small"  >
                        <AddIcon color="disabled" />
                      </IconButton>
                    </div>
                  </td>
                  <td class="cart__product__amount">
                    1,200,000đ
                  </td>
                  <td class="cart__product__delete">
                    <IconButton aria-label="delete" size="small"  >
                      <DeleteIcon color="disabled" />
                    </IconButton>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="cart__total-price">
            <span><trong>Tổng thanh toán:</trong></span>
            <span class="pay-price">
              1,390,000đ
            </span>
          </div>
          <div className="" style={{ textAlign: 'right' }}>
            <Link> <Button variant="contained" color="secondary" size="large" sx={{ marginRight: 1 }}>Tiep tuc mua hang</Button> </Link>
            <Link>  <Button variant="contained" color="primary" size="large">Thanh toan</Button></Link>
          </div>
        </div>
      </div>

    )
  }
}

export default CartPage;