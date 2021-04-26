import { Controller } from 'stimulus';
import ReactDOM from 'react-dom';
import React from 'react';
import CompanyDataAutocomplete from '../components/CompanyDataAutocomplete';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        ReactDOM.render(<CompanyDataAutocomplete />, this.element);
    }
}
