from django.shortcuts import render,redirect

def inicio(request):
    return render(request,"inicio.html")

def vistaFotos(request):
    return render(request,"vistaFotos.html")

def vistaVideos(request):
    return render(request,"vistaVideos.html")