export default {
    methods: {
      $sortFilesByType:function(fls){
        var files = {
          images:[],
          stls:[],
          dxfs:[],
          pdfs:[],
          zips:[]
        };
        for (var i = 0; i < fls.length; i++) {
          switch (fls[i].file_path.split('.').pop()) {
            case 'jpg':
            case 'png':
            files.images.push(fls[i])
              break;
            case 'stl':
            files.stls.push(fls[i])
              break;
            case 'dxf':
            files.dxfs.push(fls[i])
              break;
            case 'pdf':
            files.pdfs.push(fls[i])
              break;
            case 'zip':
            files.zips.push(fls[i])
              break;
            default:
          }
        }
        return files;
      },



    },
};
