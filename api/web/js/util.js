/**
 * 判断是否为空
 * @param value
 * @returns {boolean}
 */
function isEmpty(value) {
    if (value == null || value == "" || value == "undefined" || value == undefined || value == "null") {
        return true;
    }
    else {
        value = value.replace(/\s/g, "");
        if (value == "") {
            return true;
        }
        return false;
    }
}
/**
 * 判断是否是数字
 * @param value
 * @returns {boolean}
 */
function isNumber(value){
    if(isNaN(value)){
        return false;
    }
    else{
        return true;
    }
}
/**
 * 检查邮箱格式
 * @param email
 * @returns {boolean}
 */
function check_email(email){
    if(email){
        var reg=/^[0-9a-zA-Z_\-\.]{1}\**@\w+([-.]\w+)*\.\w+([-.]\w+)*(\s*$)/;
        if(!reg.test(email) && !check_email(email)){
            return false;
        }
        return true;
    }
    return false;
}
/**
 * 检查收机号码
 * @param mobile
 * @returns {boolean}
 */
function check_mobile(mobile) {
    var regu = /^\d{11}$/;
    var re = new RegExp(regu);
    if (!re.test(mobile)) {
        return false;
    }
    return true;
}
/**
 * 去掉字符串首尾空格
 * @param str
 * @returns {*|XML|string|void}
 */
function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
/**
 * 检查是否含有非法字符
 * @param temp_str
 * @returns {boolean}
 */
function is_forbid(temp_str){
    temp_str=trimTxt(temp_str);
    temp_str = temp_str.replace('*',"@");
    temp_str = temp_str.replace('--',"@");
    temp_str = temp_str.replace('/',"@");
    temp_str = temp_str.replace('+',"@");
    temp_str = temp_str.replace('\'',"@");
    temp_str = temp_str.replace('\\',"@");
    temp_str = temp_str.replace('$',"@");
    temp_str = temp_str.replace('^',"@");
    temp_str = temp_str.replace('.',"@");
    temp_str = temp_str.replace(';',"@");
    temp_str = temp_str.replace('<',"@");
    temp_str = temp_str.replace('>',"@");
    temp_str = temp_str.replace('"',"@");
    temp_str = temp_str.replace('=',"@");
    temp_str = temp_str.replace('{',"@");
    temp_str = temp_str.replace('}',"@");
    var forbid_str=new String('@,%,~,&');
    var forbid_array=new Array();
    forbid_array=forbid_str.split(',');
    for(i=0;i<forbid_array.length;i++){
        if(temp_str.search(new RegExp(forbid_array[i])) != -1)
            return false;
    }
    return true;
}
