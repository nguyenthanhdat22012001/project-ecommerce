// import logo from './logo.svg';
import './App.scss';
import React from 'react';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import ClientIndex from "./clients/ClientIndex";
import SignInUser from "./components/SignInUser";
import ResgisterUser from "./components/ResgisterUser";
import SignAdmin from "./components/SignAdmin";

class App extends React.Component {
  render() {
    return (
      <div className="wrapper">
            <Router>
              <Switch>
                <Route exact path="/" >
                  <ClientIndex />
                </Route>
                <Route  path="/login" >
                  <SignInUser />
                </Route>
                <Route  path="/register" >
                  <ResgisterUser />
                </Route>
                <Route  path="/admin/login" >
                  <SignAdmin />
                </Route>
              </Switch>
            </Router>
      </div>
    );
  };
};

export default App;
