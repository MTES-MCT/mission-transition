import './styles/search.scss';
import React from 'react'
import ReactDOM from 'react-dom';
// import AidSearchEngineExtension from "./components/AidSearchEngineExtension";


import SearchEngine from "./components/SearchEngine";
// import EnvironmentalTopicsHelper from './components/EnvironmentalTopicsHelper';

// ReactDOM.render(<EnvironmentalTopicsHelper />, document.querySelector('#topics-helper'));


ReactDOM.render(
  <SearchEngine/>,
  document.querySelector('#search-engine')
);

