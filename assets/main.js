import './vendor/bootstrap.min.scss';
import './vendor/lightgallery.min.scss';
import './vendor/lightslider.min.scss';
import './main.scss';

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('./js/', true, /^.*\.(js)$/))
