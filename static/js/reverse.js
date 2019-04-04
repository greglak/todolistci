    //define model
    var Contact = Backbone.Model.extend({
        urlRoot: "https://URL_SAMPLE/index.php/RestApiController/celeb",
        idAttribute: 'itemId',
        defaults: {
            name: "",
            url: "",
            price: "",
            type: ""
        }
    });

    //define collection
    var Directory = Backbone.Collection.extend({
        model: Contact,
        url: "https://URL_SAMPLE/index.php/RestApiController/celeb"
    });

    //define individual view
    var ContactView = Backbone.View.extend({
        tagName: "article",
        className: "contact-container",
        template: _.template($("#contactTemplate").html()),
        editTemplate: _.template($("#contactEditTemplate").html()),
       
        initialize: function () {
            this.listenTo(this.model, 'destroy', this.remove);
            
        },
        render: function () {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        },

        events: {
            "click button.delete": "deleteContact",
            "click button.edit": "editContact",
            "click button.save": "saveEdits",
            "click button.cancel": "cancelEdit" 
        },

        //delete a contact
        deleteContact: function () {
            console.log('delete', this.model);        
            this.model.destroy();
            directory.render();      
        },

        //switch contact to edit mode
        editContact: function () {
            this.$el.html(this.editTemplate(this.model.toJSON()));       
        },
        //save contact to edit mode
        saveEdits: function (e) {
            e.preventDefault();

            var formData = {},
                prev = this.model.previousAttributes();

            //get form data
            $(e.target).closest("form").find("input, select").not("button").each(function () {
                var el = $(this);
                formData[el.attr("class")] = el.val();
            });
            //validation
            if(formData['name']==""||formData['url']==""||formData['price']==""){
                alert("Please fill in all fields");
                console.log("Please fill in all fields");
            }else{
            var id = this.model.get('itemId');
            var n = formData['name'];
            if (!/^https:\/\//.test(formData['url'])) {
                formData['url'] = "https://" + formData['url'];
            }
            var i = formData['url'];
            var p = formData['price'];
            var t = formData['type'];
            var celeb = new Contact({itemId : id, name : n, url : i, price : p, type : t});
            celeb.save();
            //update model
            this.model.set(formData);
            //render view
            this.render();  
            }
        },

        cancelEdit: function () {
            this.render();
        }
    });

    //define master view
    var DirectoryView = Backbone.View.extend({
        el: $("#contacts"),

        initialize: function () {
            this.collection = new Directory();
            this.collection.fetch();
            this.render();
            
            this.collection.on("reset", this.render, this);
            this.collection.on("add", this.renderContact, this);
            this.collection.on("remove", this.removeContact, this);
        },

        render: function () {
            this.$el.find("article").remove();

            _.each(this.collection.models, function (item) {
                this.renderContact(item);
            }, this);
        },

        renderContact: function (item) {
            var contactView = new ContactView({
                model: item
            });
            this.$el.append(contactView.render().el);
        }, 
        //add ui events
        events: {         
            "click #add": "addContact",
        },

        //add a new contact
        addContact: function (e) {
            e.preventDefault();
            var n,i,p = "";
            var formData = {};
            $("#addContact").children("div").children("input,select").each(function (i, el) {
                if ($(el).val() !== "") {
                    formData[el.id] = $(el).val();
                }
            });
            console.log(formData);

            //validation
            if(formData['name']==undefined||formData['url']==undefined||formData['price']==undefined){
                alert("Please fill in all fields");
                console.log("Please fill in all fields");
            }else{
            
            n = formData['name'];
            
            if (!/^https:\/\//.test(formData['url'])) {
                formData['url'] = "https://" + formData['url'];
            }
            i = formData['url'];
            p = formData['price'];
            var t = formData['type'];
            console.log('name field test: ', n);
            
            var celeb = new Contact({name : n, url : i, price : p, type : t});
            celeb.save();

            console.log('addings works', celeb);
            this.collection.add(new Contact(formData));
            }
        },

        removeContact: function (removedModel) {
            var removed = removedModel.attributes;

            //remove from contacts array
            _.each(contacts, function (contact) {
                if (_.isEqual(contact, removed)) {
                    contacts.splice(_.indexOf(contacts, contact), 1);
                }
            });
        }

    });

    //create instance of master view
    var directory = new DirectoryView();

    //start history service
    Backbone.history.start();

    //define model
    var List = Backbone.Model.extend({
        urlRoot : "URL_SAMPLE/index.php/RestApiController/celeb",
        idAttribute : 'wishlistId',
        defaults : {
            userId : ''
        }
    })
    
    //create instance of model
    var list = new List();
    
    //define model
    var shareList = Backbone.Model.extend({
        urlRoot : "URL_SAMPLE/index.php/RestApiController/shareListModel",
        defaults : {
            wishlistId : ''
        }
    })
    // function to generate a sharedlist
    var sharedListView = Backbone.View.extend({
        el : '.form-group',
        
        initialise : function() {
            
        },
        render : function() {
            return this;
        },
        events : {
            "click #shareList-submit" : 'generateSharedList'
        },
        generateSharedList : function() {
            var sharedList = new shareList({wishlistID : list.get("wishlistID")});
            sharedList.save(null, {async : false,
                    success: function(response) {
                        console.log("Sharedlist generated" + response.get('message'));
                        if(response.get('status') == 200){
                            $('#info').empty();
                            $('#info').append("Sharing is caring: " + "<a target='_blank' href='" + response.get('url') + "'>" + "Link" + "</a>");
                        } else {
                            console.log("Cannot generate a sharedlist");
                        }
                    }
            });
        }
    });
    
    var generateShareListInstance =new sharedListView();
    
    $(function() {
        $('#shareList-submit').click(function(e) {
            if( $("#shareListMessage").css('display') == 'none') {
                $("#shareListMessage").fadeIn(55);
            } else {
                $("#shareListMessage").fadeOut(55);
            }
        });
    });
    

    //hides div displaying shared list and adds styling to specific classes
    $(document).ready(function () {
        $('.name').css([".form-control"]);
        $('.url').css([".form-control"]);
        $('.price').css([".form-control"]);
        $('#shareListMessage').fadeOut(55);
    });

