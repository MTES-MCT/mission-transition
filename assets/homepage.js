import './styles/homepage.scss';
import React from 'react'
import ReactDOM from 'react-dom';
import SearchEngineExtension from "./components/SearchEngineExtension";


ReactDOM.render(
    <SearchEngineExtension/>,
    document.querySelector('#search-engine-extension')
);

