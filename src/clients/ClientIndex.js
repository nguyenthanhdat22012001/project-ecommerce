import React from 'react';

import Routers from './pages/Router';
import "./styles/index.scss";
import Header from "./components/layouts/Header";
import Footer from "./components/layouts/Footer";
import ScrollToTop from "./components/layouts/ScrollToTop";


class ClientIndex extends React.Component {
    constructor(props) {
        super(props);
        this.state = {}
    };

    render() {
        return (
            <div className="client">
                <ScrollToTop/>
                    <Header/>
                <main className="client__inner">
                    <Routers />
                </main>
                <Footer />
            </div>
        );
    }
}



export default ClientIndex;
