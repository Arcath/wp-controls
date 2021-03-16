class MediaIconsControl extends React.Component{
  constructor(props){
    super(props)

    const icons = JSON.parse(atob(props.icons))
    const faIcons = JSON.parse(atob(props.faIcons))

    this.state = {
      icons: icons,
      faIcons: faIcons.map((name) => {
        return `fab fa-${name}`
      })
    }
  }

  updatePreview(){
    wp.customize.instance(this.props.control).set(this.state.icons)
  }

  updateValue(index, field, value){
    const newState = Object.assign({}, this.state)

    newState.icons[index][field] = value

    this.setState(newState)
    this.updatePreview()
  }

  swapPosition(a, b){
    const newState = Object.assign({}, this.state)

    const temp = newState.icons[a]

    newState.icons[a] = newState.icons[b]
    newState.icons[b] = temp

    this.setState(newState)
    this.updatePreview()
  }

  addIcon(){
    const newState = Object.assign({}, this.state)

    newState.icons.push({icon: '', url: '', color: '#ffffff'})

    this.setState(newState)
  }

  removeIcon(icon){
    const newState = Object.assign({}, this.state)

    newState.icons = newState.icons.filter((a, i) => {
      return i !== icon
    })

    this.setState(newState)
    this.updatePreview()
  }

  componentDidUpdate(){
    this.updatePreview()
  }

  render(){
    return <div className="media-icons-control">
      {this.state.icons.map((icon, i) => {
        return <div key={i} className="icon">
          <b>Icon #{i}</b>
          <div>
            {i !== 0 ? <button onClick={(e) => {
              e.preventDefault()

              this.swapPosition(i, i - 1)
            }}>Up</button> : ''}
            {i !== this.state.icons.length - 1 ? <button onClick={(e) => {
              e.preventDefault()

              this.swapPosition(i, i + 1)
            }}>Down</button> : ''}
            <button onClick={(e) => {
              e.preventDefault()

              this.removeIcon(i)
            }}>Remove</button>
          </div>
          <br />
          <i className={icon.icon} />
          <input value={icon.icon} onChange={(e) => {
            this.updateValue(i, 'icon', e.target.value)
          }} />
          <input value={icon.url} onChange={(e) => {
            this.updateValue(i, 'url', e.target.value)
          }} />
          <input value={icon.color} id={`${this.props.controlName}-color-${i}`} onChange={(e) => {
            this.updateValue(i, 'color', e.target.value)
          }} />
        </div>
      })}
      <button onClick={(e) => {
        e.preventDefault()

        this.addIcon()
      }}>Add</button>
      <p>
        <a href="https://fontawesome.com/icons?d=gallery&p=2&m=free" target="_BLANK">Find Icons</a>
      </p>
    </div>
  }
}

function media_icons_control(controlName, data, icons){
  const el = document.querySelector('label[data-control="' + controlName + '"]')

  ReactDOM.render(<MediaIconsControl control={controlName} icons={data} faIcons={icons} />, el)
}

jQuery(document).trigger('load-media-icons')
