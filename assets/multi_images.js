jQuery(document).on('ready', function(){
  multiImages = {
    frame: null,
    images: {}
  }

  multi_images_load_images()
})

function multi_images_bind_events(controlName){
  jQuery('*[data-customize-setting-link="' + controlName + '"]').parent('label').children('#multiImages-add').on('click', function(event){
    event.preventDefault()

    if(multiImages.frame){
      multiImages.frame.open()
      return;
    }

    multiImages.frame = wp.media({
      title: 'Select Footer Image',
      button: { text: 'Select' },
      library: { type: 'image' },
      multiple: false
    })

    multiImages.frame.on('select', function(){
      media = multiImages.frame.state().get('selection').first().toJSON()
      multiImages.images[controlName].push(media)
      multi_images_redraw_list(controlName)
    })

    multiImages.frame.open()
  })
}

function multi_images_redraw_list(controlName){
  data = []

  list = jQuery('*[data-customize-setting-link="' + controlName + '"]').parent('label').children('label').children('ul')

  jQuery(list).html('')

  for(var i in multiImages.images[controlName]){
    image = multiImages.images[controlName][i]
    console.dir(image)
    data.push(image.id)
    jQuery(list).append('<li data-index="' + i + '"><img src="' + (image.sizes.thumbnail ? image.sizes.thumbnail : image.sizes.full).url + '" width="150" height="150" /><br /><a href="#" class="mui-remove">Remove</a></li>')
  }

  jQuery(list).children('li').children('.mui-remove').on('click', function(event){
    event.preventDefault()

    index = jQuery(this).parent('li').data().index
    controlName = jQuery(this).parent('li').parent('ul').parent('label').parent('label').children('#multi-images-data').data().customizeSettingLink

    na = []
    for(var i in multiImages.images[controlName]){
      if(i != index){
        na.push(multiImages.images[controlName][i])
      }
    }

    multiImages.images[controlName] = na
    multi_images_redraw_list(controlName)
  })

  wp.customize.instance(controlName).set(data)
}

function multi_images_load_images(){
  keys = Object.keys(window.multiImagesLoad)

  for(var j in keys){
    multiImages.images[keys[j]] = []
    for(var i in window.multiImagesLoad[keys[j]]){
      multiImages.images[keys[j]].push(window.multiImagesLoad[keys[j]][i])
    }

    multi_images_bind_events(keys[j])
    multi_images_redraw_list(keys[j])
  }
}