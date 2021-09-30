import React from 'react';
import Typography from '@mui/material/Typography';
import Breadcrumbs from '@mui/material/Breadcrumbs';
import LinkBreadcrumbs from '@mui/material/Link';
import ImageGallery from 'react-image-gallery';
import FavoriteBorderIcon from '@mui/icons-material/FavoriteBorder';
import IconButton from '@mui/material/IconButton';
import Rating from '@mui/material/Rating';
import { Link } from 'react-router-dom';
import ToggleButton from '@mui/material/ToggleButton';
import ToggleButtonGroup from '@mui/material/ToggleButtonGroup';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import StoreIcon from '@mui/icons-material/Store';
import ChatIcon from '@mui/icons-material/Chat';
import { Tooltip } from '@mui/material';


import "../../styles/ProductDetail.scss";
import TabDetailProduct from "./TabDetailProduct";
import Product2 from "./Product2";


class ProductDetailPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            showDescCoupon: false
        };
    };

    images = [
        {
            original: 'https://picsum.photos/id/1018/1000/600/',
            thumbnail: 'https://picsum.photos/id/1018/250/150/',
        },
        {
            original: 'https://picsum.photos/id/1015/1000/600/',
            thumbnail: 'https://picsum.photos/id/1015/250/150/',
        },
        {
            original: 'https://picsum.photos/id/1019/1000/600/',
            thumbnail: 'https://picsum.photos/id/1019/250/150/',
        },
    ];

    handleToggleDescCoupon = () => {
        if (this.state.showDescCoupon) {
            this.setState({ showDescCoupon: false });
            console.log('oke')
        } else {
            this.setState({ showDescCoupon: true });
            console.log('oke')
        }
    }

    render() {
        return (
            <div>
                <div role="presentation">
                    <Breadcrumbs aria-label="breadcrumb">
                        <LinkBreadcrumbs underline="hover" color="inherit" href="/">
                            MUI
                        </LinkBreadcrumbs>
                        <LinkBreadcrumbs
                            underline="hover"
                            color="inherit"
                            href="/getting-started/installation/"
                        >
                            Core
                        </LinkBreadcrumbs>
                        <Typography color="text.primary">detai</Typography>
                    </Breadcrumbs>
                </div>
                <div className="row product__detail">
                    <div className="row product__detail__top">
                        <div className="product__detail__infor-product">
                            <div className="product__detail__image-galery">
                                <ImageGallery
                                    showFullscreenButton={false}
                                    showPlayButton={false}
                                    thumbnailPosition="left"
                                    showNav={false}
                                    lazyLoad={true}
                                    sizes="large"
                                    slideDuration={1000}
                                    items={this.images}
                                    originalHeight={100}
                                />
                            </div>
                            <div className="product__detail__infor">
                                <h2 className="product__detail__infor__title">Tuong ot chung mnamcho han quoc</h2>
                                <div className="product__detail__infor__rating-love">
                                    <p className="product__detail__infor__rating">
                                        <Rating name="half-rating-read" defaultValue={5} precision={0.5} readOnly />
                                        <span className="product__detail__infor__text-rating">
                                            <Link> 163 luot danh gia </Link>
                                        </span>
                                        <span className="product__detail__infor__text-buying">
                                            | 163 Luot mua
                                        </span>
                                    </p>
                                    <div className="product__detail__infor__love">
                                        <Tooltip title="them san pham yeu thich">
                                            <IconButton aria-label="delete" color="error" >
                                                <FavoriteBorderIcon sx={{ fontSize: 30 }} />
                                            </IconButton>
                                        </Tooltip>
                                        <Tooltip title="theo doi cua hang">
                                            <IconButton aria-label="delete" sx={{ color: "orangered" }} >
                                                <StoreIcon sx={{ fontSize: 30 }} />
                                            </IconButton>
                                        </Tooltip>
                                        <Tooltip title="chat voi cua hang">
                                            <IconButton aria-label="delete" color="primary" >
                                                <ChatIcon sx={{ fontSize: 30 }} />
                                            </IconButton>
                                        </Tooltip>
                                    </div>
                                </div>
                                <div className="product__detail__infor__brand">
                                    Thuong hieu:
                                    <Link> Amoda </Link>
                                </div>
                                <div className="flexBoxColunm product__detail__infor__price">
                                    <span className="product__detail__infor__price-new">
                                        56.000 ₫
                                    </span>
                                    <div className="product__detail__infor__price-old">
                                        <span>109.000 ₫</span>
                                        <span>-49%</span>
                                    </div>
                                </div>
                                <div className="product__detail__infor__coupon">
                                    <h4>Uu dai</h4>
                                    <Button
                                        onClick={this.handleToggleDescCoupon}
                                    >
                                        <div className="product__detail__infor__tag-coupon" >
                                            <div
                                                className="product__detail__infor__tag-coupon-name product__detail__infor__tag-coupon-has-desc"
                                            >
                                                chi 1k, nhan ngay 100k tro len la het khong con gi
                                            </div>
                                            <div className={this.state.showDescCoupon ? "product__detail__infor__tag-coupon-desc action-coupon" : "product__detail__infor__tag-coupon-desc"}>
                                                <div className="backgroundColor-white">
                                                    <h5> chi 1k, nhan ngay 100k tro len la het khong chi 1k, nhan ngay 100k tro len la het</h5>
                                                    <p>chi 1k, nhan ngay 100k tro len la het khong chi 1k, nhan ngay 100k tro len la het khong chi 1k, nhan ngay 100k tro len la het khongchi 1k, nhan ngay 100k tro len la het khong khongchi 1k, nhan ngay 100k tro len la het khong</p>
                                                </div>
                                            </div>
                                        </div>
                                    </Button>
                                </div>
                                <div className="product__detail__infor__attribute">
                                    <h4>mau sac</h4>
                                    <ToggleButtonGroup
                                        value={'left'}
                                        exclusive
                                        // onChange={handleAlignment}
                                        aria-label="text alignment"
                                        size="small"
                                    >
                                        <ToggleButton value="left" aria-label="left aligned">
                                            Do
                                        </ToggleButton>
                                        <ToggleButton value="Den" aria-label="left aligned">
                                            Den
                                        </ToggleButton>
                                        <ToggleButton value="trang" aria-label="left aligned">
                                            trang
                                        </ToggleButton>
                                        <ToggleButton value="vang" aria-label="left aligned">
                                            vang
                                        </ToggleButton>
                                    </ToggleButtonGroup>
                                </div>
                                <div className="product__detail__infor__attribute">
                                    <h4>So luong</h4>
                                    <TextField
                                        id="outlined-number"
                                        label=""
                                        size="small"
                                        sx={{ maxWidth: 100 }}
                                        defaultValue={1}
                                        type="number"
                                        InputLabelProps={{
                                            shrink: true,
                                        }}
                                    />
                                </div>
                                <div className="group-btn-cart">
                                    <Button variant="contained" color="secondary" size="large" sx={{ marginRight: 1 }}>Mua ngay</Button>
                                    <Button variant="contained" color="primary" size="large">Them vao gio hang</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row product__detail__body">
                        <article className="product__detail__content">
                            <TabDetailProduct />
                            <div className="product__detail__relative">
                                <h4>san pham cung cua hang</h4>
                                <div className="product__detail__relative-list">
                                    <div className="product__detail__relative-item">
                                       <Product2/>
                                    </div>
                                </div>
                            </div>
                            <div className="product__detail__relative">
                                <h4>san pham lien quan</h4>
                                <div className="product__detail__relative-list">
                                    <div className="product__detail__relative-item">
                                       <Product2/>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <sidebar className="product__detail__sidebar">
                            <div className="row">
                                <h4>Quang cao san pham</h4>
                                <div className="row">
                                     <Product2/>
                                </div>
                            </div>
                        </sidebar>
                    </div>
                </div>
            </div>
        );
    }
}


export default ProductDetailPage;
