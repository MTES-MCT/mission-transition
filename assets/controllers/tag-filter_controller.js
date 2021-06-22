import { Controller } from 'stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    connect() {
        this.element.innerHTML = 'hello';
    }
}
