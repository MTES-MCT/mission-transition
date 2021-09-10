import './styles/search.scss';
import React from 'react'
import ReactDOM from 'react-dom';
import AidSearchEngine from "./components/AidSearchEngine";
// import EnvironmentalTopicsHelper from './components/EnvironmentalTopicsHelper';

// ReactDOM.render(<EnvironmentalTopicsHelper />, document.querySelector('#topics-helper'));
let environmentalFilters = document.querySelector('#aid-search-engine').dataset.environmentalTopics;

console.log(environmentalFilters)

ReactDOM.render(
    <AidSearchEngine
        filters={environmentalFilters}
    />,
    document.querySelector('#aid-search-engine')
);
