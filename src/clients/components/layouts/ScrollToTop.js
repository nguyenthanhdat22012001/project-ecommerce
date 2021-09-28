import React from "react";

import '../../styles/ScrollToTop.scss';

 class ScrollToTop extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            is_visible: false
        };
    }

    componentDidMount() {
        document.addEventListener("scroll", (e)=> {
            this.toggleVisibility();
        });
    }

    toggleVisibility = ()=> {
        if (window.pageYOffset > 300) {
            this.setState({
                is_visible: true
            });
        } else {
            this.setState({
                is_visible: false
            });
        }
    }

    scrollToTop= ()=> {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }

    render() {
        return (
            <div className={this.state.is_visible ? "scroll-to-top active" : "scroll-to-top"}>
                        <div onClick={() => this.scrollToTop()}>
                            <img src='../assets/back-to-top.png' alt='Go to top' />
                        </div>
            </div>
        );
    }
}


export default ScrollToTop;