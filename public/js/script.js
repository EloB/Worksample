(function($, undefined) {
$(function() {
    $('html').removeClass('no-js').addClass('js');
    
    function List(element, behavior) {
        this.element = $(element);
        this.behavior = behavior;
        
        this.behavior();
    }
    
    List.prototype = {
        reload: function(callback) {
            return this.load(this.element.data('reload'), callback);
        },
        load: function(url, callback) {
            if(callback == null) {
                callback = $.noop;
            }
            
            return $.get(url, { format: 'html' }, $.proxy(function(data) {
                var $content = $(data);
                
                this.element.replaceWith($content).remove();
                this.element = $content;
                
                this.behavior();
                
                callback.apply(this, arguments);
            }, this));
        }
    };
    
    var
    rowDeleteProgram,
    list = new List('.program-list', function() {
        var scope = this;
        
        $('.icon-trash', this.element).tooltip();
        
        $('.cell', this.element).popover({ placement: 'bottom' });
        
        this.element.on('click', '.icon-trash', function() {
            rowDeleteProgram = this;
        });
                
        this.element.on('click', '.pagination a, thead a', function() {
            scope.load(this.href);
            
            return false;
        });
    });
    
    $('.program-list-reload').on('click', function() {
        list.reload();
        
        return false;
    });
    
    var
    $modalProgram = $('#modal-program'),
    $formProgram = $('form', $modalProgram),
    $submitProgram = $('.btn.save', $modalProgram);
    
    $formProgram.on('submit', function() {
        $submitProgram.button('loading');
        
        $formProgram.load($formProgram.attr('action') + ' form > *', $formProgram.serializeArray(), function() {
            if($formProgram.find('.alert-error').length == 0) {
                $modalProgram.modal('hide');
                
                list.reload();
                
                $modalProgram.modal('hide');
            }
            
            $submitProgram.button('reset');
        });
        
        return false;
    });
    
    $modalProgram.on('show', function() {
        $modalProgram.find('textarea, input').val('');
    });
    
    $submitProgram.click(function() {
        $formProgram.submit();
        
        return false;
    });
    
    $('#modal-program-delete .btn.yes').on('click', function() {
        $.get(rowDeleteProgram.href, function() {
            list.reload();
        });
    });
    
    $('#modal-information').modal('show');
});
})(jQuery);