import React from 'react';
import Box from '@mui/material/Box';
import SwipeableDrawer from '@mui/material/SwipeableDrawer';
import List from '@mui/material/List';
import Divider from '@mui/material/Divider';
import ListItem from '@mui/material/ListItem';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import HomeIcon from '@mui/icons-material/Home';

class Navbar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            openNavbar: false
        }
    };

    static getDerivedStateFromProps(props, state) {
        if (state.openNavbar !== props.openNavbar) {
            return { openNavbar: props.openNavbar }
        };
    };

    toggleDrawer = (anchor, open) => (event) => {
        if (event.type === 'keydown' && (event.key === 'Tab' || event.key === 'Shift')) {
            return;
        }

        this.setState({ [anchor]: open });
        this.props.closeNavbar(open);
    };

    list = (anchor) => (
        <Box
            sx={{ width: anchor === 'top' || anchor === 'bottom' ? 'auto' : 250 }}
            role="presentation"
            onClick={this.toggleDrawer(anchor, false)}
            onKeyDown={this.toggleDrawer(anchor, false)}
        >
            <List>
                <ListItem button key="Trang Chu">
                    <ListItemIcon>
                        <HomeIcon />
                    </ListItemIcon>
                    <ListItemText primary="Trang Chu" />
                </ListItem>
                <ListItem button key="Danh Muc">
                    <ListItemIcon>
                        <HomeIcon />
                    </ListItemIcon>
                    <ListItemText primary="Danh Muc" />
                </ListItem>
            </List>
            <Divider />
            <List>
                <ListItem button key="Dang Nhap">
                    <ListItemIcon>
                        <HomeIcon />
                    </ListItemIcon>
                    <ListItemText primary="Dang Nhap" />
                </ListItem>
            </List>
            <List>
                <ListItem button key="Dang Ki">
                    <ListItemIcon>
                        <HomeIcon />
                    </ListItemIcon>
                    <ListItemText primary="Dang Ki" />
                </ListItem>
            </List>
        </Box>
    );

    render() {
        return (
            <div>
                <React.Fragment key={'left'}>
                    <SwipeableDrawer
                        anchor={'left'}
                        open={this.state.openNavbar}
                        onClose={this.toggleDrawer('opentNavbar', false)}
                        onOpen={this.toggleDrawer('opentNavbar', true)}
                    >
                        {this.list("left")}
                    </SwipeableDrawer>
                </React.Fragment>
            </div>
        );
    }
}

export default Navbar;