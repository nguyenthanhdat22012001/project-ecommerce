import React from 'react';
import "../../styles/Product.scss"

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Box from '@mui/material/Box';
import Rating from '@mui/material/Rating';
import StarIcon from '@mui/icons-material/Star';


class Sidebar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {};
    };

    style = {
        width: '100%',
        maxWidth: 360,
        bgcolor: 'background.paper',
    };

    render() {
        return (
            <div className="product__sidebar__inner">
                <div className="row product__sidebar__category">
                    <h4 className="product__sidebar__title">Danh muc</h4>
                    <List sx={this.style} component="nav" aria-label="mailbox folders">
                        <ListItem button>
                            <ListItemText primary="Inbox" />
                        </ListItem>
                        <ListItem button>
                            <ListItemText primary="Drafts" />
                        </ListItem>
                        <ListItem button>
                            <ListItemText primary="Trash" />
                        </ListItem>
                        <ListItem button>
                            <ListItemText primary="Spam" />
                        </ListItem>
                    </List>
                </div>
                <div className="row product__sidebar__brand">
                    <h4 className="product__sidebar__title">Thuong hieu</h4>
                    <FormGroup>
                        <FormControlLabel control={<Checkbox defaultChecked />} label="Label" />
                        <FormControlLabel disabled control={<Checkbox />} label="Disabled" />
                    </FormGroup>
                </div>
                <div className="row product__sidebar__rating">
                    <h4 className="product__sidebar__title">Danh gia</h4>
                    <Box
                        sx={{
                            width: 200,
                            display: 'flex',
                            alignItems: 'center',
                        }}
                    >
                        <Rating
                            name="text-feedback"
                            value={5}
                            readOnly
                            precision={0.5}
                            emptyIcon={<StarIcon style={{ opacity: 0.55 }} fontSize="inherit" />}
                        />
                    </Box>
                    <Box
                        sx={{
                            width: 200,
                            display: 'flex',
                            alignItems: 'center',
                        }}
                    >
                        <Rating
                            name="text-feedback"
                            value={4}
                            readOnly
                            precision={0.5}
                            emptyIcon={<StarIcon style={{ opacity: 0.55 }} fontSize="inherit" />}
                        />
                        <Box sx={{ ml: 2 }}>Tro len</Box>
                    </Box>
                </div>
            </div>
        );
    }
}



export default Sidebar;
