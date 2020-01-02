import './bootstrapValidator.js';
$(function () {
    $('#login_form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            mobile: {
                validators: {
                    notEmpty: {message: '手机号不能为空'},
                    regexp: {regexp: /^1\d{10}$/, message: '请输入正确的手机号'}
                }
            },
            password: {
                validators: {
                    notEmpty: {message: '密码不能为空'},
                    stringLength: {min: 6, message: '密码长度必须大于6位'}
                }
            }
        }
    });
});