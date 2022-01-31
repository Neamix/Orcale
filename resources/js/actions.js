   
export default {
    install : function(app,option) {
        app.directive('action',(binding,vnode) => {
            console.log(binding)
        })
    }
}
