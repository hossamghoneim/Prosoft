
class MultipleUploader {

    #multipleUploader;
    #$imagesUploadInput;
    uploadedImages;
    constructor()
    {
        this.#multipleUploader   = document.getElementById('multiple-uploader');
        this.#$imagesUploadInput = document.createElement('input')
        this.uploadedImages = [];
    }

    init( { maxUpload = 10 , maxSize = 2 , formSelector = 'form' , filesInpName = 'images' , relatedImages = []  } = {} )
    {
        const self = this;
        const form = document.querySelector(formSelector);

        const toDataURL = url => fetch(url)
            .then(response => response.blob())
            .then(blob => new Promise((resolve, reject) => {
                const reader = new FileReader()
                reader.onloadend = () => resolve(reader.result)
                reader.onerror = reject
                reader.readAsDataURL(blob)
            }))

        function dataURLtoFile(dataUrl, filename) {
            let arr = dataUrl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {type:mime});
        }



        if (! this.#multipleUploader ) // check if the end user didnt write the multiple uploader div
            throw new Error('The multiple uploader element doesnt exist');

        if (! form ) // check if there is no form with this selector
            throw new Error('We couldn\'t find a form with this selector: ' + formSelector);

        // ensure that the form has enctype attribute with the value multipart/form-data
        form.enctype = 'multipart/form-data'

        if ( document.getElementById('max-upload-number') )
            document.getElementById('max-upload-number').innerHTML = translate('Upload up to') + ' ' + maxUpload + ' ' + translate('images');

        // create multiple file input and make it hidden
        this.#$imagesUploadInput.type       = 'file';
        this.#$imagesUploadInput.name       = `${filesInpName}[]`;
        this.#$imagesUploadInput.multiple   = true;
        this.#$imagesUploadInput.accept     = "image/*";
        this.#$imagesUploadInput.style.setProperty('display','none','important');
        // create multiple file input and make it hidden

        // append the newly created input to the form with the help of the formSelector provided by the user
        document.querySelector(formSelector).append( this.#$imagesUploadInput );
        // document.querySelector(formSelector).append( this.lastImages);
        this.#multipleUploader.addEventListener("click", (e) => {

            if ( e.target.className === 'multiple-uploader' || e.target.className === 'mup-msg' || e.target.className === 'mup-main-msg' )
                this.#$imagesUploadInput.click() // trigger the input file to upload images

        });

        if (relatedImages.length > 0) {

            const globalDT = new DataTransfer();
            this.#multipleUploader.querySelector('.mup-msg').style.setProperty('display', 'none');
            let promises = [];
            relatedImages.forEach(function (imagePath, index) {
                promises.push( toDataURL(getFilePath(imagePath))
                    .then(dataUrl => {
                        let fileData = dataURLtoFile(dataUrl, imagePath);
                        globalDT.items.add(fileData)
                    }))
            });

            Promise.all(promises).then(() => {
                    self.#$imagesUploadInput.files = globalDT.files;
                }
            ).then(() => {
                self.onChange(self.#$imagesUploadInput.files,maxUpload,maxSize);
            });

        }


        // preview the uploaded images
        this.#$imagesUploadInput.addEventListener("change",function (){
            self.onChange(this.files,maxUpload,maxSize);
        });

        // event for deleting uploaded images
        document.addEventListener('click',function(e){

            if( e.target.className === 'image-container' ) // clicked on remove pseudo element
            {
                const imageIndex        = e.target.getAttribute(`data-image-index`)
                const imageIsAcceptable = e.target.getAttribute(`data-acceptable-image`)

                e.target.remove() // remove the html element from the dom

                if ( +imageIsAcceptable )
                    self.#removeFileFromInput(imageIndex)

                if ( document.querySelectorAll('.image-container').length === 0 ) // if there are no images
                    self.clear();


                self.#reorderFilesIndices(); // reorder images indices
            }

        });



        return this;

    }

    clear()
    {
        this.#multipleUploader.querySelectorAll('.image-container').forEach( image => image.remove() );
        this.#multipleUploader.querySelectorAll('.mup-msg').forEach( msg => msg.style.setProperty('display', 'flex') );
        this.#$imagesUploadInput.value = [];
    }

    #removeFileFromInput( deletedIndex )
    {
        // remove the delete file from input
        const dt = new DataTransfer()

        this.uploadedImages.splice(deletedIndex, 1);

        for (const [ index, file] of Object.entries( this.uploadedImages ))
            dt.items.add(file)

        this.#$imagesUploadInput.files = dt.files
    }

    #reorderFilesIndices()
    {
        document.querySelectorAll('.image-container').forEach( ( element, index) => {
            element.setAttribute('data-image-index', index.toString() );
            element.setAttribute('id',`mup-image-${ index }`)
        });
    }

    #checkImageSize( imageIndex, imageSize , maxSize   )
    {
        return  imageSize['unit'] !== 'MB' || ( imageSize['unit'] === 'MB' && ( imageSize['size'] <= maxSize ) ) ; // return true if acceptable
    }

    #bytesToSize(bytes)
    {
        const sizes = ['Bytes', 'KB', 'MB']

        const i = parseInt( Math.floor(Math.log(bytes) / Math.log(1024) ), 10)

        if (i === 0)
            return {size: bytes , unit: sizes[i] }
        else
            return {size: (bytes / (1024 ** i)).toFixed(1) , unit: sizes[i] }

    }

    onChange (files,maxUpload,maxSize) {

        if (files.length > 0)
        {
            //self.#multipleUploader.querySelectorAll('.image-container').forEach( image => image.remove() ); // clear the previous rendered images
            this.#multipleUploader.querySelector('.mup-msg').style.setProperty('display', 'none'); // hide the hint texts inside drop zone

            // if the length of uploaded images greater than the images uploaded by the user, the maximum uploaded will be considered
            const uploadedImagesCount       = files.length > maxUpload ? maxUpload : files.length;
            const unAcceptableImagesIndices = [];


            for (let index = 0; index < uploadedImagesCount; index++) {

                const imageSize             = this.#bytesToSize( files[ index ].size );
                const isImageSizeAcceptable = this.#checkImageSize( index , imageSize , maxSize , 'MB' );
                this.uploadedImages.push(files[ index ]);

                // appended the newly created image to the multiple uploader
                this.#multipleUploader.innerHTML += `
                <div class="image-container" data-image-index="${ this.uploadedImages.length - 1}" id="mup-image-${ this.uploadedImages.length - 1 }" data-acceptable-image="${ +isImageSizeAcceptable }" >
                    <div class="image-size"> ${ imageSize['size'] + ' ' + imageSize['unit'] } </div>
                    ${ !isImageSizeAcceptable ? `<div class="exceeded-size"> greater than ${ maxSize } MB </div>` : '' }
                    <img src="${ URL.createObjectURL( files[ index ]) }"  class="image-preview" alt="" />
                </div>
                 <p class="invalid-feedback" id="images_${ this.uploadedImages.length - 1 }"></p>`;

                if ( ! isImageSizeAcceptable )
                    unAcceptableImagesIndices.push( index )

            }

            const dt = new DataTransfer();

            for (const [ index, file] of Object.entries(this.uploadedImages))
                dt.items.add( file )

            this.#$imagesUploadInput.files = dt.files

            unAcceptableImagesIndices.forEach( (index ) => this.#removeFileFromInput(index, false ))

        }

    }

}
