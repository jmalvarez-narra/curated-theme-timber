import './scss/bootstrap.min.scss';
import './scss/lightgallery.min.scss';
import './scss/lightslider.min.scss';
import './main.scss';

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('./js/', true, /^.*\.(js)$/))
