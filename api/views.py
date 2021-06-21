from django.http import response
from django.http.response import HttpResponse, JsonResponse
from django.shortcuts import render
# from django.contrib.auth.models import auth
from .models import Users, Meetings, Social_links
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

    else:
        return HttpResponse('Not Supported')
        
def base64_to_image(base64_string):
    format, imgstr = base64_string.split(';base64,')
    ext = format.split('/')[-1]
    return ContentFile(base64.b64decode(imgstr), name=uuid4().hex + "." + ext)


@csrf_exempt
def login(request):
    if request.method == "POST":
        email = request.POST['email']
        password = request.POST['password']
        if Users.objects.filter(email=email).exists():
            user = Users.objects.get(email=email)
            user_password = user.password
            if password == user_password:
                data = {}
                data['error'] = False 
                data['success_msg'] = 'Login Successfully'
                data['users'] = serializers.serialize("json", [Users.objects.get(id=user.pk)])
                data['users'] = json.loads(data['users'])
                return JsonResponse(data)
                
            else:
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Password Not Match'
                return JsonResponse(data)  
        else:
            data = {}
            data['error'] = 'True'
            data['error_msg'] = 'Email doesnot exist'
            return JsonResponse(data)

    else:
        return HttpResponse('Login Not Supported')
            

@csrf_exempt
def meeting(request):
    if request.method == "POST":
        user_id = request.POST['user_id']
        link = request.POST['link']
        if (Users.objects.filter(id=user_id).exists()):
            meeting_link = Meetings(link=link, user_id=user_id)
            meeting_link.save()
            data = {}
            data['error'] = False
            data['success_msg'] = 'Meeting_link saved successfully' 
            return JsonResponse(data) 
        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User_id doesnot exist please enter the valid User_id!'
            return JsonResponse(data)

    else:
        return HttpResponse('Meeting Not Supported')


@csrf_exempt
def social(request):
    if request.method == "POST":
        user_id = request.POST['user_id']
        insta = request.POST['insta']
        fb = request.POST['fb']
        linkedIn = request.POST['linkedIn']
        youtube = request.POST['youtube']
        if (Users.objects.filter(id=user_id).exists()):
            if (Social_links.objects.filter(user_id=user_id).exists()):
                links = Social_links.objects.get(user_id = user_id)
                links.insta = insta
                links.fb = fb
                links.linkedIn = linkedIn
                links.youtube = youtube
                links.save()
                data = {}
                data['error'] = False
                data['success_msg'] = 'Social_link updated successfully' 
                return JsonResponse(data)
            else:
                social_link = Social_links(user_id=user_id, insta=insta, fb=fb, linkedIn=linkedIn, youtube=youtube)
                social_link.save()
                data = {}
                data['error'] = False
                data['success_msg'] = 'Social_link saved successfully' 
                return JsonResponse(data) 
                
        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User_id doesnot exist please enter the valid User_id!'
            return JsonResponse(data)

    else:
        return HttpResponse('Social Not Supported')