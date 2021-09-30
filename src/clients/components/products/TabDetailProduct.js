import * as React from 'react';
import PropTypes from 'prop-types';
import Tabs from '@mui/material/Tabs';
import Tab from '@mui/material/Tab';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import ShowMoreText from "react-show-more-text";
import Rating from '@mui/material/Rating';
import { TextField } from '@mui/material';
import Button from '@mui/material/Button';
import ThumbUpIcon from '@mui/icons-material/ThumbUp';
import MoreVertIcon from '@mui/icons-material/MoreVert';
import IconButton from '@mui/material/IconButton';
import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import StorefrontIcon from '@mui/icons-material/Storefront';
import Pagination from '@mui/material/Pagination';
import Stack from '@mui/material/Stack';


function TabPanel(props) {
  const { children, value, index, ...other } = props;
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`simple-tabpanel-${index}`}
      aria-labelledby={`simple-tab-${index}`}
      {...other}
    >
      {value === index && (
        <Box sx={{ p: 3 }}>
          <Typography>{children}</Typography>
        </Box>
      )}
    </div>
  );
}

TabPanel.propTypes = {
  children: PropTypes.node,
  index: PropTypes.number.isRequired,
  value: PropTypes.number.isRequired,
};

function a11yProps(index) {
  return {
    id: `simple-tab-${index}`,
    'aria-controls': `simple-tabpanel-${index}`,
  };
}

export default function BasicTabs() {
  const [value, setValue] = React.useState(0);
  const [openReprotComment, setopenReprotComment] = React.useState(null);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const executeOnClick = (isExpanded) => {
    console.log(isExpanded);
  }

  const handleOpenReprotComment = (event) => {
    setopenReprotComment(event.currentTarget);
  };
  const handleCloseReprotComment = () => {
    setopenReprotComment(null);
  };

  return (
    <Box sx={{ width: '100%' }}>
      <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
        <Tabs value={value} onChange={handleChange} aria-label="basic tabs example">
          <Tab label="mo ta san pham" {...a11yProps(0)} />
          <Tab label="Danh gia san pham" {...a11yProps(1)} />
          <Tab label="Nhan xet san pham" {...a11yProps(2)} />
        </Tabs>
      </Box>
      <TabPanel value={value} index={0}>
        <ShowMoreText
          /* Default options */
          lines={3}
          more="Xem them"
          less="An mo Ta"
          className="content-css"
          anchorClass="my-anchor-css-class"
          onClick={executeOnClick}
          expanded={false}
          // width={280}
          truncatedEndingComponent={"... "}
        >
          Lorem ipsum dolor sit amet, consectetur{" "}
          <a
            href="https://www.yahoo.com/"
            target="_blank"
            rel="noopener noreferrer"
          >
            yahoo.com
          </a>{" "}
          adipiscing elit, sed do eiusmod tempor incididunt
          <p
          >
            www.google.bg
          </p> ut labore et dolore magna amet, consectetur adipiscing elit,
          sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
          nisi ut aliquip ex Lorem ipsum dolor sit amet, consectetur adipiscing
          elit, sed do eiusmod tempor incididunt ut labore et dolore magna
          aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
          laboris nisi ut aliquip ex Lorem ipsum dolor sit amet, consectetur
          adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
        </ShowMoreText>
      </TabPanel>
      <TabPanel value={value} index={1}>
        <div className="tab-comment-rating">
          <div className="tab-comment-rating__ranting">
            <div className="tab-comment-rating__summary">
              <div className="tab-comment-rating__total-start">
                <span className="tab-comment-rating__average">4.9</span>
                <span className="tab-comment-rating__max">/5</span>
              </div>
              <div className="tab-comment-rating__stars-icon">
                <Rating name="half-rating-read" defaultValue={5} precision={0.5} size="large" readOnly />
              </div>
              <div className="tab-comment-rating__total-evaluate">
                13344 danh gia
              </div>
            </div>
            <div className="tab-comment-rating__list flexBoxColunm">
              <div className="tab-comment-rating__item">
                <Rating name="half-rating-read" defaultValue={5} precision={0.5} size="medium" readOnly />
                <span>1234 danh gia</span>
              </div>
              <div className="tab-comment-rating__item">
                <Rating name="half-rating-read" defaultValue={4} precision={0.5} size="medium" readOnly />
                <span>1234 danh gia</span>
              </div>
              <div className="tab-comment-rating__item">
                <Rating name="half-rating-read" defaultValue={3} precision={0.5} size="medium" readOnly />
                <span>1234 danh gia</span>
              </div>
              <div className="tab-comment-rating__item">
                <Rating name="half-rating-read" defaultValue={2} precision={0.5} size="medium" readOnly />
                <span>1234 danh gia</span>
              </div>
              <div className="tab-comment-rating__item">
                <Rating name="half-rating-read" defaultValue={1} precision={0.5} size="medium" readOnly />
                <span>1234 danh gia</span>
              </div>
            </div>
          </div>
        </div>
      </TabPanel>
      <TabPanel value={value} index={2}>
        <div className="tab-comment">
          <div className="tab-comment__row-comment">
            <h5 className="tab-comment__title">Nhan xet cua ban</h5>
            <div className="tab-comment__box-comment">
              <TextField fullWidth label="Nhan xet" variant="outlined" />
              <div className="tab-comment__btn-comment">
                <Rating name="half-rating-read" defaultValue={1} precision={0.5} size="large" />
                <Button variant="contained" color="primary" size="large">Binh luan</Button>
              </div>
            </div>
            <div className="tab-comment__box-list-comments">
              <h5 className="tab-comment__title">Nhan xet ve san pham</h5>
              <div className="tab-comment__review-comment">
                <div className="tab-comment__review-top">
                  <Rating name="half-rating-read" defaultValue={4} precision={0.5} size="small" readOnly />
                  <span>2 tuan truoc</span>
                </div>
                <div className="tab-comment__review-middle">boi Nguyen Phong</div>
                <div className="tab-comment__review-content">
                  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than
                </div>
                <div className="tab-comment__review-bottom">
                  <IconButton aria-label="thumbUp" sx={{ fontSize: 1 }}>
                    <ThumbUpIcon color="disabled" sx={{ marginRight: 1 }} /> <span style={{ fontSize: 16 }}>3</span>
                  </IconButton>
                  <IconButton
                    // id="button-report-comment"
                    arial-controls="menu-report-comment"
                    aria-haspopup="true"
                    aria-label="thumbUp"
                    size="small"
                    onClick={handleOpenReprotComment}
                  >
                    <MoreVertIcon color="disabled" />
                  </IconButton>
                  <Menu
                    id="menu-report-comment"
                    anchorEl={openReprotComment}
                    open={Boolean(openReprotComment)}
                    onClose={handleCloseReprotComment}
                    MenuListProps={{
                      'aria-labelledby': 'button-report-comment',
                    }}
                  >
                    <MenuItem onClick={handleCloseReprotComment}>khong huu ich</MenuItem>
                    <MenuItem onClick={handleCloseReprotComment}>Bao cao lam dung</MenuItem>
                  </Menu>
                </div>
              </div>
              <div className="tab-comment__reply-comment">
                <div className="tab-comment__review-top">
                  <div className="tab-comment__name-seller"><StorefrontIcon /> phan hoi tu nha ban </div>
                  <span>3 tuan truoc</span>
                </div>
                <div className="tab-comment__review-middle"></div>
                <div className="tab-comment__review-content">
                  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than  hang tot qua , dang mua, hop li, lan sau se mua neu co nhu cau, dong goi can than
                </div>
                <div className="tab-comment__review-bottom">
                  <IconButton aria-label="thumbUp" sx={{ fontSize: 1 }}>
                    <ThumbUpIcon color="disabled" sx={{ marginRight: 1 }} /> <span style={{ fontSize: 16 }}>3</span>
                  </IconButton>
                  <IconButton
                    // id="button-report-comment"
                    arial-controls="menu-report-comment"
                    aria-haspopup="true"
                    aria-label="thumbUp"
                    size="small"
                    onClick={handleOpenReprotComment}
                  >
                    <MoreVertIcon color="disabled" />
                  </IconButton>
                  <Menu
                    id="menu-report-comment"
                    anchorEl={openReprotComment}
                    open={Boolean(openReprotComment)}
                    onClose={handleCloseReprotComment}
                    MenuListProps={{
                      'aria-labelledby': 'button-report-comment',
                    }}
                  >
                    <MenuItem onClick={handleCloseReprotComment}>Bo danh dau "khong huu ich"</MenuItem>
                    <MenuItem onClick={handleCloseReprotComment}>Bao cao lam dung</MenuItem>
                  </Menu>
                </div>
              </div>
              <div className="paginion">
                <Stack spacing={2}>
                  <Pagination count={10} color="secondary" />
                </Stack>
              </div>
            </div>
          </div>
        </div>
      </TabPanel>
    </Box>
  );
}
