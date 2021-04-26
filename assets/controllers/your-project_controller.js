import { Controller } from 'stimulus';
import ReactDOM from 'react-dom';
import React from 'react';
import FirstStepProjectDefiner from '../components/FirstStepProjectDefiner';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        optgroups: Object,
    };

    connect() {
        ReactDOM.render(<FirstStepProjectDefiner optgroups={this.optgroupsValue} />, this.element);
    }
}
