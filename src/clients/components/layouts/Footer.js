import React from 'react';
import { Link } from 'react-router-dom';
import '../../styles/Footer.scss';
import IconButton from '@mui/material/IconButton';
import FacebookIcon from '@mui/icons-material/Facebook';
import GoogleIcon from '@mui/icons-material/Google';
import TwitterIcon from '@mui/icons-material/Twitter';

class Footer extends React.Component {
  render() {
    return <footer className="footer">
      <div className="footer__container">
        <div className="footer__inner">
          <div className="footer__col">
            <h3 className="footer__title">LAZADA VIỆT NAM</h3>
            <ul class="footer__list">
              <li class="footer__li"><Link to="#">Về Lazada Việt Nam</Link></li>
              <li class="footer__li"><Link to="#">Bán hàng cùng Lazada</Link></li>
              <li class="footer__li"><Link to="#">Điều khoản sử dụng</Link></li>
              <li class="footer__li"><Link to="#">Chính sách bảo mật</Link></li>
              <li class="footer__li"><Link to="#">Quy chế hoạt động sàn Lazada</Link></li>
            </ul>
          </div>
          <div className="footer__col">
            <h3 className="footer__title">LIÊN HỆ VỚI LAZADA</h3>
            <ul class="footer__list">
              <li class="footer__li"><Link to="#">Hotline &amp; Chat trực tuyến (24/7)</Link></li>
              <li class="footer__li"><Link to="#">Trung tâm hỗ trợ</Link></li>
              <li class="footer__li"><Link to="#">Hướng dẫn đặt hàng</Link></li>
              <li class="footer__li"><Link to="#">Giao hàng &amp; Nhận hàng</Link></li>
              <li class="footer__li"><Link to="#">Chính sách hàng nhập khẩu</Link></li>
              <li class="footer__li"><Link to="#">Hướng dẫn đổi trả hàng</Link></li>
            </ul>
          </div>
          <div className="footer__col footer__brand">
            <div className="row footer__brand__top">
              <div className="footer__brand__top__logo">
                <div className="footer__brand__top__image">
                <img  src="https://laz-img-cdn.alicdn.com/images/ims-web/TB1T7K2d8Cw3KVjSZFuXXcAOpXa.png" alt="" />
                </div>
                {/* <div className="footer__brand__top__title">MElACO</div> */}
                <div className="footer__brand__top__icons">
                  <IconButton aria-label="facebook" color="primary" >
                    <FacebookIcon sx={{ fontSize: 40 }} />
                  </IconButton>
                  <IconButton aria-label="facebook" color="error" >
                    <GoogleIcon sx={{ fontSize: 40 }} />
                  </IconButton>
                  <IconButton aria-label="facebook" color="primary" >
                    <TwitterIcon sx={{ fontSize: 40 }} />
                  </IconButton>
                </div>
              </div>
            </div>
            <div className="row footer__brand__bottom">
              <h4 className="footer__brand__bottom__title">CÔNG TY TNHH RECESS</h4>
              <p className="footer__brand__bottom__desc">Giấy CNĐKDN: 0308808576 – Ngày cấp: 06/5/2009, được sửa đổi lần thứ 19 ngày 15/8/2019.
                Cơ quan cấp: Phòng Đăng ký kinh doanh – Sở kế hoạch và Đầu tư TP.HCM
                Địa chỉ đăng ký kinh doanh: Tầng 19, Tòa nhà Saigon Centre – Tháp 2, 67 Lê Lợi, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh, Việt Nam.</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  }

}

export default Footer;