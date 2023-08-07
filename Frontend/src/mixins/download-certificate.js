export default () => ({
  methods: {
    download(training) {
      console.log('download', training);
      window.axios.get(`/wp-json/apovoice/v1/certificate/${training.trainingSeriesId}/${training.year}`, { responseType: 'blob' })
        .then(response => {
          if (response.data.type === 'application/pdf') {
            let fileName = response.headers['content-disposition'];
            fileName = fileName ? fileName = fileName.substring(fileName.indexOf('="') + 2, fileName.indexOf('.pdf"') + 4) : 'certificate.pdf';
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.download = fileName;
            link.href = url;
            link.click();
          }
        });
    },
    isComplete(training, user) {
      return (user.trainingResults[training.id] && !!parseInt(user.trainingResults[training.id].is_complete))
        && training.id === this.currentTrainingId;
    },
  },
});
