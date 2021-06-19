from django.http import response
from django.http.response import HttpResponse, JsonResponse
from django.shortcuts import render
# from django.contrib.auth.models import auth
from .models import Users
from django.views.decorators.csrf import csrf_exempt
from django.core import serializers
import json
import base64
from django.core.files.base import ContentFile
from uuid import uuid4


# Create your views here.
@csrf_exempt
def users(request):
    if request.method == "POST":
        # first_name = request.POST['first_name']
        # last_name = request.POST['last_name']
        # user_name = request.POST['user_name']
        # password = request.POST['password']
        # confirm_password = request.POST['confirm_password']
        # email = request.POST['email'] 
        
        name = request.POST['name']
        email = request.POST['email']
        password = request.POST['password']
        profession = request.POST['profession']
        phone_no = request.POST['phone_no']
        image = request.POST['image']
        images = base64_to_image(image)
        
        if Users.objects.filter(email=email).exists():
            data = {}
            data['error'] = True
            data['error_msg'] = 'Email already exists'
            return JsonResponse(data)
        
        if Users.objects.filter(phone_no=phone_no).exists():
            data = {}
            data['error'] = True
            data['error_msg'] = 'phone number already exists'
            return JsonResponse(data)
        
        if len(password)<6:
            data = {}
            data['error'] = True
            data['error_msg'] = 'Password must be greater then six characters'
            return JsonResponse(data)
        
        if name.strip() == '' or email.strip() == '':
            data = {}
            data['error'] = True
            data['error_msg'] = 'Please enter Name and Email correctly'
            return JsonResponse(data)
        user = Users(name=name, email=email, password=password, profession=profession, phone_no=phone_no, image=images)
        user.save()
        # user = Users.objects.get(id=user.pk)
        data = {}
        data['error'] = False
        data['success_msg'] = 'User created successfully'
        # data['users'] = serializers.serialize("json", [Users.objects.get(id=user.pk)])
        # data['users'] = json.loads(data['users'])
        return JsonResponse(data)

        # response = serializers.serialize("json", data)
        # return JsonResponse(response, safe=False)
        # return HttpResponse(json.dumps(response), content_type="application/json") 
    else:
        return HttpResponse('Not Supported')
        
def base64_to_image(base64_string):
    format, imgstr = base64_string.split(';base64,')
    ext = format.split('/')[-1]
    return ContentFile(base64.b64decode(imgstr), name=uuid4().hex + "." + ext)





# from django.http import response
# from django.http.response import HttpResponse, JsonResponse
# # from django.shortcuts import render
# # from django.contrib.auth.models import auth
# from .models import Users
# from django.views.decorators.csrf import csrf_exempt
# from django.core import serializers
# import json
# import base64
# from django.core.files.base import ContentFile
# from uuid import uuid4
# # Create your views here.
# @csrf_exempt
# def users(request):
#     if request.method == "POST":
    
#         name = request.POST['name']
#         email = request.POST['email']
#         password = request.POST['password']
#         profession = request.POST['profession']
#         phone_no = request.POST['phone_no']
#         image = request.POST['image']
#         images = base64_to_image(image)

#         if Users.objects.filter(email=email).exists():

#             data = {}
#             data['error'] = 'True'
#             data['error_msg'] = 'Email Already Exists!!'
#             return JsonResponse(data)

#         elif int(len(password)) < 6:
#             data = {}
#             data['error'] = 'True'
#             data['error_msg'] = 'Password must be contain 6 characters!!'
#             return JsonResponse(data)
#         elif Users.objects.filter(phone_no=phone_no).exists():
#             data = {}
#             data['error'] = 'True'
#             data['error_msg'] = 'Phone Number Already Exists!!'
#             return JsonResponse(data)
        
#         elif name != name.strip():
#             data = {}
#             data['error'] = 'True'
#             data['error_msg'] = 'Name field is required'
#             return JsonResponse(data)
        
#         elif email != email.strip():
#             data = {}
#             data['error'] = 'True'
#             data['error_msg'] = 'Email field is required'
#             return JsonResponse(data)
        
#         elif password != password.strip():
#             data = {}
#             data['error'] = 'True'
#             data['error_msg'] = 'Password field is required'
#             return JsonResponse(data)

#         else:
#             user = Users(name=name, email=email, password=password, profession=profession, phone_no=phone_no, image=images)
#             user.save()
#             # user = Users.objects.get(id=user.pk)
        
        
#             data = {}
#             data['error'] = 'False'
#             data['success_msg'] = 'User created successfully'
#             # data['users'] = serializers.serialize("json", [Users.objects.get(id=user.pk)])
#             # data['users'] = json.loads(data['users'])
#             return JsonResponse(data)
        
#             # return HttpResponse(json.dumps(response), content_type="application/json")
#             # return JsonResponse(json.dumps(data), content_type="application/json")
#             # return JsonResponse(data)
        
 
#     else:
#         return HttpResponse('Not Supported')
        
# def base64_to_image(base64_string):
#     format, imgstr = base64_string.split(';base64,')
#     ext = format.split('/')[-1]
#     return ContentFile(base64.b64decode(imgstr), name=uuid4().hex + "." + ext)