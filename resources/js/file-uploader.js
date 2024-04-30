export async function uploadFile(file, url) {
  // request data
  let formData = new FormData()
  formData.append('file', file.file)
  
  // track status and upload file
  file.status = 'loading'
  let response = await fetch(url, { method: 'POST', body: formData })
  
  // change status when upload complete; this begins as 'null' until we change it to 'loading', then changes to 'true' or 'false' depending on the final status of the request
  file.status = response.ok
  
  return response
}

export function uploadFiles(files, url) {
  return Promise.all(files.map(file => uploadFile(file, url)))
}

export default function createUploader(url) {
  return {
    uploadFile: function (file) {
      return uploadFile(file, url)
    },
    uploadFiles: function (files) {
    return uploadFiles(files, url)
    }
  }
}