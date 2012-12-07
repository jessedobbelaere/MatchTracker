//
//  FirstViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 6/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "FirstViewController.h"
#import <RestKit/RestKit.h>
#import "Sport.h"
#import "LoginViewController.h"

@interface FirstViewController ()

@end

@implementation FirstViewController {
    BOOL didLogin;
}

- (void)viewDidLoad
{
    //[super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
        
    [super viewDidLoad];
    
    didLogin = NO;
    
    // Load some sports
    [self loadSports];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


- (void)viewDidAppear:(BOOL)animated {  
    
    // Show login screen
//    QRootElement *root = [[QRootElement alloc] init];
//    root.title = @"Test";
//    root.controllerName = @"LoginViewController";
//    
//    LoginViewController *loginViewController = (LoginViewController *) [[LoginViewController alloc] initWithRoot:root];
//    UINavigationController *navigation = [[UINavigationController alloc] initWithRootViewController:loginViewController];
//
//    [self presentModalViewController:navigation animated:YES];
    
    // Show login screen
//    QRootElement *root = [LoginViewController createLoginForm];
    
    if(!didLogin) {
        QRootElement *root = [[QRootElement alloc] initWithJSONFile:@"LoginForm"];
        LoginViewController *loginViewController = (LoginViewController *) [[LoginViewController alloc] initWithRoot:root];
        UINavigationController *navigation = [[UINavigationController alloc] initWithRootViewController:loginViewController];
        didLogin = YES;
        [self presentModalViewController:navigation animated:YES];
    }
}


// Get the sports
- (void)loadSports
{
    RKObjectMapping* articleMapping = [RKObjectMapping mappingForClass:[Sport class]];
    [articleMapping addAttributeMappingsFromDictionary:@{
        @"id": @"identifier",
        @"name": @"name"
     }];
    
    RKResponseDescriptor *responseDescriptor = [RKResponseDescriptor responseDescriptorWithMapping:articleMapping pathPattern:nil keyPath:@"sports" statusCodes:RKStatusCodeIndexSetForClass(RKStatusCodeClassSuccessful)];
    
    NSURL *URL = [NSURL URLWithString:@"http://matchtracker.localhost/api/sports"];
    NSURLRequest *request = [NSURLRequest requestWithURL:URL];
    RKObjectRequestOperation *objectRequestOperation = [[RKObjectRequestOperation alloc] initWithRequest:request responseDescriptors:@[ responseDescriptor ]];
    [objectRequestOperation setCompletionBlockWithSuccess:^(RKObjectRequestOperation *operation, RKMappingResult *mappingResult) {
        RKLogInfo(@"Loaded collection of %i Sports", [mappingResult count]);
        for(Sport *sport in [mappingResult array]) {
            NSLog(@"Sport met id=%@ en naam=%@", [sport identifier], [sport name]);
        }
    } failure:^(RKObjectRequestOperation *operation, NSError *error) {
        RKLogError(@"Operation failed with error: %@", error);
    }];
    
    [objectRequestOperation start];
}

@end
