import React from 'react';
import axios from 'axios'

const Header = () => {

    const clearData = () => {
        axios.post('/api/items/truncate', {})
            .then( () =>  window.location.reload())
    };



    return(
        <nav className="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div className="container">
                <a className="navbar-brand" href="/">
                    IPSupply
                </a>
                <button className="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav  ml-auto">
                        <li className="nav-item ">
                            <a className="nav-link cursor_pointer" onClick={() => clearData()}>Clear All Data</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    )
};

export default Header
