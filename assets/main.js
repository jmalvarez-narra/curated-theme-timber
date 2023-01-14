import './main.scss';

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('./js/', true, /^.*\.(js)$/))
