import React from 'react';

import "../../styles/Shopping.scss";
import Stepper from "./Stepper";

class ChekOutPage extends React.Component {

    render() {
        return (
            <div className="checkout">
               <Stepper  stepCart={1}  />
            </div>
        )
    }
}

export default ChekOutPage;