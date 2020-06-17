import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import Items from './Item/Items.js'
import Header from "./Layout/Header";
//Redux store
import { Provider } from 'react-redux';
import {createStore, combineReducers, applyMiddleware, compose} from 'redux'
import thunk from 'redux-thunk'


//import reducer
import reducers from '../store/index'
import itemsReducer from '../store/reducers/itemsReducer'
const rootReducer = combineReducers(reducers);

const composeEnhancers =
    typeof window === 'object' &&
    window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ ?
        window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__({
            // Specify extension’s options like name, actionsBlacklist, actionsCreators, serialize...
        }) : compose;

const enhancer = composeEnhancers(
    applyMiddleware(thunk),
    // other store enhancers if any
);

const store = createStore(rootReducer, {} ,enhancer)
// -------- //

export default class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <Header/>
                <div className="container">
                    <Items />
                </div>
            </BrowserRouter>
        );
    }
}


if (document.getElementById('app')) {

    ReactDOM.render(<Provider store={store}><App /></Provider>, document.getElementById('app'));
}
