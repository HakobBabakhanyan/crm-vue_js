import Vue from "vue";
import {library} from '@fortawesome/fontawesome-svg-core'
import {
    faUser, faCogs, faCubes, faDollarSign, faAngleDoubleRight, faUsers,
    faTachometerAlt, faBuilding,faPiggyBank
} from '@fortawesome/free-solid-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

library.add(faUser, faCogs, faCubes, faDollarSign, faAngleDoubleRight, faUsers, faTachometerAlt,faBuilding,faPiggyBank);

Vue.component('FontAwesomeIcon', FontAwesomeIcon);
