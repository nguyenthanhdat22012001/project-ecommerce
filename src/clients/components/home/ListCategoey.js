import React from 'react';

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import Divider from '@mui/material/Divider';


class ListCategory extends React.Component {
    constructor(props) {
        super(props);
        this.state = {};
    };

    style={
        width: '100%',
        maxWidth: 360,
        bgcolor: 'background.paper',
      };

    render() {
        return (
            <List sx={this.style} component="nav" aria-label="mailbox folders">
            <ListItem button>
              <ListItemText primary="Inbox" />
            </ListItem>
            <Divider />
            <ListItem button divider>
              <ListItemText primary="Drafts" />
            </ListItem>
            <ListItem button>
              <ListItemText primary="Trash" />
            </ListItem>
            <Divider light />
            <ListItem button>
              <ListItemText primary="Spam" />
            </ListItem>
          </List>
        );
    }
}



export default ListCategory;
